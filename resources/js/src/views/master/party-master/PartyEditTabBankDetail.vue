<template>
    <div>
        <b-form @submit.prevent="submitFormData">
            <b-row>
                <b-col md="12">
                    <hr>
                    <h6>Party Bank Details</h6>
                    <hr>
                </b-col>

                <b-col md="6">
                    <b-form-group
                        label="Beneficiary Name"
                        label-for="beneficiary-name"
                    >
                        <b-form-input
                            id="beneficiary-name"
                            placeholder="Beneficiary Name"
                            v-model="formData.beneficiaryName"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="Bank Name"
                        label-for="bank-name"
                    >
                        <b-form-input
                            id="bank-name"
                            placeholder="Bank Name"
                            v-model="formData.bankName"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="Account No"
                        label-for="account-no"
                    >
                        <b-form-input
                            id="account-no"
                            placeholder="Account No"
                            type="number"
                            v-model="formData.accountNo"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="Branch Name"
                        label-for="branch-name"
                    >
                        <b-form-input
                            id="branch-name"
                            placeholder="Branch Name"
                            v-model="formData.branchName"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="Branch Code"
                        label-for="branch-code"
                    >
                        <b-form-input
                            id="branch-code"
                            placeholder="Branch Code"
                            v-model="formData.branchCode"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="IFS Code"
                        label-for="ifs-code"
                    >
                        <b-form-input
                            id="ifs-code"
                            placeholder="IFS Code"
                            v-model="formData.ifscCode"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="MICR Code"
                        label-for="micr-code"
                    >
                        <b-form-input
                            id="micr-code"
                            placeholder="MICR Code"
                            v-model="formData.micrCode"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="SWIFT Code"
                        label-for="swift-code"
                    >
                        <b-form-input
                            id="swift-code"
                            placeholder="SWIFT Code"
                            v-model="formData.swiftCode"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="I BAN Number"
                        label-for="iban-number"
                    >
                        <b-form-input
                            id="iban-number"
                            placeholder="I BAN Number"
                            v-model="formData.iBanNo"
                        />
                    </b-form-group>
                </b-col>
            </b-row>

            <hr>
            <!-- Action Buttons -->
            <b-button
                variant="primary"
                class="mb-1 mb-sm-0 mr-0 mr-sm-1 float-right"
                :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                type="submit"
            >
                Save Changes
            </b-button>
        </b-form>
    </div>
</template>

<script>
    import {
        BButton,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BForm,
        BTable,
        BCard,
        BCardHeader,
        BCardTitle,
        BFormCheckbox,
        BFormTextarea,
    } from 'bootstrap-vue'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import { ref, onUnmounted } from '@vue/composition-api'
    import router from '@/router'
    import store from '@/store'
    import {useToast} from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {required, numeric, email} from '@validations'
    import {ValidationProvider, ValidationObserver, validate} from 'vee-validate'
    import partyStoreModule from '../partyStoreModule'

    export default {
        components: {
            BButton,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BForm,
            BTable,
            BCard,
            BCardHeader,
            BCardTitle,
            BFormCheckbox,
            BFormTextarea,
            vSelect,
        },
        directives: {
            Ripple,
        },
        created() {
            this.$store.dispatch('partyStoreModule/fetchPartyDetail', {id: router.currentRoute.params.id})
                .then(res  => {
                    if (typeof (res.data.data.bankDetails) === "object"){
                        this.formData = res.data.data.bankDetails
                    }
                })
        },
        setup() {
            const APP_STORE_MODULE_NAME = 'master-add'
            if (!store.hasModule(APP_STORE_MODULE_NAME)) store.registerModule(APP_STORE_MODULE_NAME, partyStoreModule)
            onUnmounted(() => {
                if (store.hasModule(APP_STORE_MODULE_NAME)) store.unregisterModule(APP_STORE_MODULE_NAME)
            })

            const partyFormData = {
                id: router.currentRoute.params.id,
                isBankDetails: true,
                beneficiaryName: null,
                bankName: null,
                accountNo: null,
                branchName: null,
                branchCode: null,
                ifscCode: null,
                micrCode: null,
                swiftCode: null,
                iBanNo: null,
            }

            const formData = ref(JSON.parse(JSON.stringify(partyFormData)))

            const resetGroupData = () => {
                formData.value = JSON.parse(JSON.stringify(partyFormData))
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetGroupData)

            return {
                formData,

                refFormObserver,
                getValidationState,
                resetForm,
                resetGroupData,
            }
        },
        methods: {
            submitFormData(){
                this.$store.dispatch('master-add/editPartyMaster', this.formData).then(res => {
                    this.$toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Bank Details Added',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: `You have successfully Bank Details`,
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
