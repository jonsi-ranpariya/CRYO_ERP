<template>
    <b-card-code>
        <validation-observer ref="simpleRules">
            <b-form>
                <b-row>
                    <b-col md="12">
                        <b-form-group>
                            <validation-provider
                                #default="{ errors }"
                                name="HSN/SAC Description"
                                rules="required"
                            >
                                <label for="codeDescription">HSN/SAC Description <span
                                    class="text-danger erp_required_star"
                                >*</span></label>
                                <b-form-input
                                    id="codeDescription"
                                    v-model="partyFormData.codeDescription"
                                    placeholder="HSN/SAC Description"
                                    v-uppercaseInput
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group>
                            <validation-provider
                                #default="{ errors }"
                                name="HSN/SAC No"
                                rules="required"
                            >
                                <label for="codeNo">HSN/SAC No <span
                                    class="text-danger erp_required_star"
                                >*</span></label>
                                <b-form-input
                                    id="codeNo"
                                    v-model="partyFormData.codeNo"
                                    placeholder="HSN/SAC No"
                                    v-uppercaseInput
                                    trim
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="GL A/c"
                            label-for="codeGlAcc"
                        >
                            <v-select
                                v-model="partyFormData.codeGlAcc"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="GlAccountOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="codeGlAcc"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="CGST (%)"
                            label-for="codeCGSTPercentage"
                        >
                            <b-form-input
                                id="codeCGSTPercentage"
                                v-model="partyFormData.codeCGSTPercentage"
                                placeholder="CGST (%)"
                                type="number"
                                min="0"
                                max="100"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="CGST GL A/c"
                            label-for="codeCGSTGlAcc"
                        >
                            <v-select
                                v-model="partyFormData.codeCGSTGlAcc"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="GlAccountOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="codeCGSTGlAcc"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="SGST (%)"
                            label-for="codeSGSTPercentage"
                        >
                            <b-form-input
                                id="codeSGSTPercentage"
                                v-model="partyFormData.codeSGSTPercentage"
                                placeholder="SGST (%)"
                                type="number"
                                min="0"
                                max="100"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="SGST GL A/c"
                            label-for="codeSGSTGlAcc"
                        >
                            <v-select
                                v-model="partyFormData.codeSGSTGlAcc"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="GlAccountOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="codeSGSTGlAcc"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="IGST (%)"
                            label-for="codeIGSTPercentage"
                        >
                            <b-form-input
                                id="codeIGSTPercentage"
                                v-model="partyFormData.codeIGSTPercentage"
                                placeholder="IGST (%)"
                                type="number"
                                min="0"
                                max="100"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="IGST GL A/c"
                            label-for="codeIGSTGlAcc"
                        >
                            <v-select
                                v-model="partyFormData.codeIGSTGlAcc"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="GlAccountOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="codeIGSTGlAcc"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Cess (%)"
                            label-for="codeCessPercentage"
                        >
                            <b-form-input
                                id="codeCessPercentage"
                                v-model="partyFormData.codeCessPercentage"
                                placeholder="Cess (%)"
                                type="number"
                                min="0"
                                max="100"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Cess GL A/c"
                            label-for="codeCessGlAcc"
                        >
                            <v-select
                                v-model="partyFormData.codeCessGlAcc"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="GlAccountOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="codeCessGlAcc"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Excise Register"
                            label-for="codeExciseRegister"
                        >
                            <v-select
                                v-model="partyFormData.codeExciseRegister"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="ExciseRegisterOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="codeExciseRegister"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <!-- submit and reset -->
                    <b-col>
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            type="submit"
                            variant="primary"
                            class="mr-1"
                            @click.prevent="validationForm"
                        >
                            Submit
                        </b-button>

                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>
    </b-card-code>
</template>

<script>
import BCardCode from '@core/components/b-card-code'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import {
    BRow, BCol, BFormGroup, BFormInput, BFormCheckbox, BForm, BButton,
} from 'bootstrap-vue'
import { required } from '@validations'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { ref, onUnmounted } from '@vue/composition-api'
import itemStoreModule from '../itemStoreModule'
import axios from '@axios'
import Swal from 'sweetalert2'
import { uppercaseInput } from '@core/utils/utils'

export default {
    components: {
        BCardCode,
        ValidationProvider,
        ValidationObserver,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormCheckbox,
        BForm,
        BButton,
        vSelect
    },
    directives: {
        Ripple,
        uppercaseInput,
    },
    methods: {
        validationForm() {
            this.$refs.simpleRules.validate()
                .then(success => {
                    if (success) {

                        axios.post('/api/item-hsn-sac-code-exist',
                            {
                                codeNo: this.partyFormData.codeNo
                            }
                        )
                            .then(res => {
                                if (res.data.data === true) {

                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Item HSN/SAC Code ' + this.partyFormData.codeNo + ' Already Exist!',
                                    })

                                } else {

                                    // save Data

                                    store.dispatch('hsnsacmaster-add/addHsnSacMaster', this.partyFormData)
                                        .then(response => {

                                            if (response.status = 200) {

                                                this.$router.push({ name: 'item-hsn-sac-code' })

                                                this.$toast({
                                                    component: ToastificationContent,
                                                    position: 'top-right',
                                                    props: {
                                                        title: 'HSN/SAC Code Created',
                                                        icon: 'CheckSquareIcon',
                                                        variant: 'success',
                                                        text: `You have successfully Created New Code ${this.partyFormData.codeDescription}.`,
                                                    },
                                                })
                                            }

                                        })
                                }
                            })

                    }
                })
        },

    },
    setup() {

        const HSNSAC_APP_STORE_MODULE_NAME = 'hsnsacmaster-add'

        // Register module
        if (!store.hasModule(HSNSAC_APP_STORE_MODULE_NAME)) store.registerModule(HSNSAC_APP_STORE_MODULE_NAME, itemStoreModule)

        // UnRegister on leave
        onUnmounted(() => {
            if (store.hasModule(HSNSAC_APP_STORE_MODULE_NAME)) store.unregisterModule(HSNSAC_APP_STORE_MODULE_NAME)
        })

        const partyFormData = ref({
            id: null,
            codeDescription: null,
            codeNo: null,
            codeGlAcc: null,
            codeCGSTPercentage: 0,
            codeCGSTGlAcc: null,
            codeSGSTPercentage: 0,
            codeSGSTGlAcc: null,
            codeIGSTPercentage: 0,
            codeIGSTGlAcc: null,
            codeCessPercentage: 0,
            codeCessGlAcc: null,
            codeExciseRegister: 1,
        })

        return {
            partyFormData,
            GlAccountOption: [{
                label: 'Account 1',
                value: 1
            }, {
                label: 'Account 2',
                value: 2
            }, {
                label: 'Service Provider',
                value: 3
            }, {
                label: 'General',
                value: 4
            }, {
                label: 'Dealer',
                value: 5
            }],
            ExciseRegisterOption: [{
                label: 'Not Applicable',
                value: 1
            }, {
                label: 'RG-1',
                value: 2
            }, {
                label: 'RG 23 A',
                value: 3
            }, {
                label: 'RG 23 C',
                value: 4
            }],
            required,
        }
    },
}
</script>
