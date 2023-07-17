<template>
    <div>
        <validation-observer ref="simpleRules" #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(submitFormData)">
                <b-row>
                    <b-col md="12">
                        <hr>
                    </b-col>
                    <b-col md="6">
                        <hr>
                        <h5>Enquiry Received By</h5>
                        <hr>
                        <validation-provider
                            #default="{ errors }"
                            name="Receive Email"
                            :rules="`${formData.receiveEmailCheck === true ? 'required|email' : ''}`"
                        >
                            <b-form-group
                                label="Email"
                                label-for="receiveEmail"
                                :state="errors.length > 0 ? false : null"
                            >
                                <b-input-group>
                                    <b-form-input
                                        placeholder="Email Id"
                                        v-model="formData.receivedEmail"
                                        :disabled="formData.receiveEmailCheck === false"
                                        :state="errors.length > 0 ? false : null"
                                    />
                                    <b-input-group-append is-text>
                                        <b-form-checkbox
                                            id="receiveEmail"
                                            name="checkbox-input"
                                            v-model="formData.receiveEmailCheck"
                                            @change="getReceiveEmailId($event)"
                                        />
                                    </b-input-group-append>
                                </b-input-group>
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="{ errors }"
                            name="Receive Fax"
                            :rules="`${formData.receiveFaxCheck === true ? 'required' : ''}`"
                        >
                            <b-form-group
                                label="Fax"
                                label-for="receiveFax"
                                :state="errors.length > 0 ? false : null"
                            >
                                <b-input-group>
                                    <b-form-input
                                        placeholder="Fax"
                                        v-model="formData.receivedFax"
                                        :disabled="formData.receiveFaxCheck === false"
                                        :state="errors.length > 0 ? false : null"
                                    />
                                    <b-input-group-append is-text>
                                        <b-form-checkbox
                                            id="receiveFax"
                                            name="checkbox-input"
                                            v-model="formData.receiveFaxCheck"
                                            @change="getReceiveFax($event)"
                                        />
                                    </b-input-group-append>
                                </b-input-group>
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="{ errors }"
                            name="Receive Verbal"
                            :rules="`${formData.receiveVerbalCheck === true ? 'required' : ''}`"
                        >
                            <b-form-group
                                label="Verbal"
                                label-for="receiveVerbal"
                                :state="errors.length > 0 ? false : null"
                            >
                                <b-input-group>
                                    <b-form-input
                                        placeholder="Verbal"
                                        v-model="formData.receivedVerbal"
                                        :disabled="formData.receiveVerbalCheck === false"
                                        :state="errors.length > 0 ? false : null"
                                    />
                                    <b-input-group-append is-text>
                                        <b-form-checkbox
                                            id="receiveVerbal"
                                            name="checkbox-input"
                                            v-model="formData.receiveVerbalCheck"
                                            @change="getReceiveVerbal($event)"
                                        />
                                    </b-input-group-append>
                                </b-input-group>
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="{ errors }"
                            name="Receive Whats App"
                            :rules="`${formData.sendWhatsApp === true ? 'required' : ''}`"
                        >
                            <b-form-group
                                label="Whats App"
                                label-for="whatsApp"
                                :state="errors.length > 0 ? false : null"
                            >
                                <b-input-group>
                                    <b-form-input
                                        placeholder="Whats App"
                                        v-model="formData.whatsApp"
                                        :disabled="formData.sendWhatsApp === false"
                                        :state="errors.length > 0 ? false : null"
                                    />
                                    <b-input-group-append is-text>
                                        <b-form-checkbox
                                            id="sendWhatsApp"
                                            name="checkbox-input"
                                            v-model="formData.sendWhatsApp"
                                            @change="getSendWhatsApp($event)"
                                        />
                                    </b-input-group-append>
                                </b-input-group>
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                        <b-form-group>
                            <b-form-checkbox
                                id="receivePost"
                                name="checkbox-input"
                                class="mt-1 ml-1"
                                v-model="formData.receivedPost"
                            >
                                Post
                            </b-form-checkbox>
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <hr>
                        <h5>Send Confirmation By</h5>
                        <hr>
                        <validation-provider
                            #default="{ errors }"
                            name="Confirm Email Id"
                            :rules="`${formData.sendEmailCheck === true ? 'required|email' : ''}`"
                        >
                            <b-form-group
                                label="Email"
                                label-for="sendEmail"
                                :state="errors.length > 0 ? false : null"
                            >
                                <b-input-group>
                                    <b-form-input
                                        placeholder="Email Id"
                                        v-model="formData.sendEmail"
                                        :disabled="formData.sendEmailCheck === false"
                                        :state="errors.length > 0 ? false : null"
                                    />
                                    <b-input-group-append is-text>
                                        <b-form-checkbox
                                            id="sendEmail"
                                            name="checkbox-input"
                                            v-model="formData.sendEmailCheck"
                                            @change="getSendEmailId($event)"
                                        />
                                    </b-input-group-append>
                                </b-input-group>
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="{ errors }"
                            name="Confirm Fax"
                            :rules="`${formData.sendFaxCheck === true ? 'required' : ''}`"
                        >
                            <b-form-group
                                label="Fax"
                                label-for="sendFax"
                                :state="errors.length > 0 ? false : null"
                            >
                                <b-input-group>
                                    <b-form-input
                                        placeholder="Fax"
                                        v-model="formData.sendFax"
                                        :disabled="formData.sendFaxCheck === false"
                                        :state="errors.length > 0 ? false : null"
                                    />
                                    <b-input-group-append is-text>
                                        <b-form-checkbox
                                            id="sendFax"
                                            name="checkbox-input"
                                            v-model="formData.sendFaxCheck"
                                            @change="getSendFax($event)"
                                        />
                                    </b-input-group-append>
                                </b-input-group>
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                        <b-form-group>
                            <b-form-checkbox
                                id="sendPost"
                                name="checkbox-input"
                                class="mt-1 ml-1"
                                v-model="formData.sendPost"
                            >
                                Post
                            </b-form-checkbox>
                        </b-form-group>
                    </b-col>
                    <b-col md="12">
                        <hr>
                        <b-button
                            variant="primary"
                            class="float-right"
                            type="submit"
                        >
                            Save
                        </b-button>
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>
    </div>
</template>
<script>
import {
    BButton,
    BRow,
    BCol,
    BFormGroup,
    BInputGroup,
    BFormInput,
    BForm,
    BTable,
    BCard,
    BCardHeader,
    BCardTitle,
    BFormCheckbox,
    BFormTextarea,
    BFormInvalidFeedback,
    BInputGroupPrepend,
    BInputGroupAppend,
    BDropdown,
    BDropdownItem,
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import router from '@/router'
import store from '@/store'
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import formValidation from '@core/comp-functions/forms/form-validation'
import { required, numeric, email } from '@validations'
import { ref, onUnmounted } from '@vue/composition-api'
import { ValidationProvider, ValidationObserver, validate } from 'vee-validate'
import salesStoreModule from '../../salesStoreModule'

export default {
    components: {
        BButton,
        BRow,
        BCol,
        BFormGroup,
        BInputGroup,
        BInputGroupPrepend,
        BInputGroupAppend,
        BFormInput,
        BForm,
        BTable,
        BCard,
        BCardHeader,
        BCardTitle,
        BFormCheckbox,
        BFormTextarea,
        BFormInvalidFeedback,
        BDropdown,
        BDropdownItem,
        vSelect,

        ValidationProvider,
        ValidationObserver
    },
    data() {
        return {
            receiveEmail: null,
            customerFaxNo: null,
        }
    },
    created() {
        this.$http.get(`/api/sales-enquiry/${router.currentRoute.params.id}`)
            .then(res => {
                if (typeof (res.data.data.confirmationData) === 'object') {
                    this.formData = res.data.data.confirmationData
                }
            })
    },
    setup() {
        const toast = useToast()
        const APP_STORE_MODULE_NAME = 'sales-module'
        if (!store.hasModule(APP_STORE_MODULE_NAME)) store.registerModule(APP_STORE_MODULE_NAME, salesStoreModule)
        /* onUnmounted(() => {
            if (store.hasModule(APP_STORE_MODULE_NAME)) store.unregisterModule(APP_STORE_MODULE_NAME)
        }) */

        const partyDetailFormData = {
            id: router.currentRoute.params.id,
            isConfirmationTab: true,
            receivedEmail: null,
            receivedFax: null,
            receivedVerbal: null,
            receivedPost: null,
            sendEmail: null,
            sendFax: null,
            sendPost: null,
            receiveEmailCheck: true,
            receiveFaxCheck: null,
            receiveVerbalCheck: null,
            sendEmailCheck: null,
            sendFaxCheck: null,
            sendWhatsApp: null,
            whatsApp: null,
        }

        const formData = ref(JSON.parse(JSON.stringify(partyDetailFormData)))
        const resetGroupData = () => {
            formData.value = JSON.parse(JSON.stringify(partyDetailFormData))
        }

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetGroupData)

        return {
            formData,
            refFormObserver,
            getValidationState,
            resetForm,
            resetGroupData,
        }
    },
    methods: {
        getReceiveEmailId(e) {
            if (e === true) {
                this.formData.receivedEmail = this.itemData?.contactPersonEmailId
            } else {
                this.formData.receivedEmail = null
            }
        },
        getReceiveFax(e) {
            if (e === true) {
                this.formData.receivedFax = this.itemData?.customerFaxNo
            } else {
                this.formData.receivedFax = null
            }
        },
        getReceiveVerbal(e) {
            if (e === true) {
                this.formData.receivedVerbal = this.itemData?.kindAttn.label
            } else {
                this.formData.receivedVerbal = null
            }
        },
        getSendEmailId(e) {
            if (e === true) {
                this.formData.sendEmail = this.itemData?.contactPersonEmailId
            } else {
                this.formData.sendEmail = null
            }
        },
        getSendFax(e) {
            if (e === true) {
                this.formData.sendFax = this.itemData?.customerFaxNo
            } else {
                this.formData.sendFax = null
            }
        },
        getSendWhatsApp(e) {
            if (e === true) {
                this.formData.whatsApp = this.itemData?.contactPersonMobileNo
            } else {
                this.formData.whatsApp = null
            }
        },
        async submitFormData() {
            await store.dispatch('sales-module/saveConfirmation', this.formData)
                .then(response => {
                    if (response.status === 200) {
                        this.$toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Confirmation Saved',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Save Confirmation.`,
                            },
                        })
                    }
                })
                .catch(() => {
                    this.$toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Error',
                            icon: 'AlertCircleIcon',
                            variant: 'danger',
                            text: 'Internal server error',
                        },
                    })
                })
        }
    }
}
</script>
<style lang="scss">
@import '~@core/scss/vue/libs/vue-select.scss';
</style>
<style lang="scss">
@import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
