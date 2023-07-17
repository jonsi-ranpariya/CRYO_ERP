<template>
    <div>
        <b-form @submit.prevent="submitFormData">
            <b-row>
                <b-col md="12">
                    <hr>
                    <h6>Party Tax Details</h6>
                    <hr>
                </b-col>

                <b-col md="3">
                    <b-form-group
                        label="GSTIN"
                        label-for="party-tax-gst"
                    >
                        <b-form-input
                            id="party-tax-gst"
                            placeholder="GSTIN"
                            v-model="formData.gstin"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="PAN No."
                        label-for="party-tax-pan"
                    >
                        <b-form-input
                            id="party-tax-pan"
                            placeholder="PAN No."
                            v-model="formData.panNo"
                        />
                    </b-form-group>
                </b-col>
                <b-col md=3>
                    <b-form-group
                        label="CIN NO:"
                        label-for="party-tax-cin-no"
                    >
                        <b-form-input
                            id="party-tax-cin-no"
                            placeholder="CIN NO"
                            v-model="formData.cinNo"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="TAN NO:"
                        label-for="party-tax-tan-no"
                    >
                        <b-form-input
                            id="party-tax-tan-no"
                            placeholder="TAN NO"
                            v-model="formData.tanNo"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="UDYAM NO:"
                        label-for="party-tax-udyam-no"
                    >
                        <b-form-input
                            id="party-tax-udyam-no"
                            placeholder="UDYAM NO"
                            v-model="formData.udyamNo"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="UID"
                        label-for="party-tax-uid"
                    >
                        <b-form-input
                            id="party-tax-uid"
                            placeholder="UID"
                            v-model="formData.uid"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="ARN"
                        label-for="party-tax-arn"
                    >
                        <b-form-input
                            id="party-tax-arn"
                            placeholder="ARN"
                            v-model="formData.arn"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="TIN VAT No."
                        label-for="party-tax-tin-vat"
                    >
                        <b-form-input
                            id="party-tax-tin-vat"
                            placeholder="TIN VAT No."
                            v-model="formData.tinVatNo"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="TIN C.S.T No."
                        label-for="party-tax-cst"
                    >
                        <b-form-input
                            id="party-tax-cst"
                            placeholder="TIN C.S.T No."
                            v-model="formData.tinCstNo"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="ECC No."
                        label-for="party-tax-ecc"
                    >
                        <b-form-input
                            id="party-tax-ecc"
                            placeholder="ECC No."
                            v-model="formData.eccNo"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Range"
                        label-for="party-tax-range"
                    >
                        <b-form-input
                            id="party-tax-range"
                            placeholder="Range"
                            v-model="formData.range"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Division"
                        label-for="party-tax-division"
                    >
                        <b-form-input
                            id="party-tax-division"
                            placeholder="Division"
                            v-model="formData.division"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Service Tax No."
                        label-for="party-tax-service-tax-no"
                    >
                        <b-form-input
                            id="party-tax-service-tax-no"
                            placeholder="Service Tax No."
                            v-model="formData.serviceTaxNo"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="NSIC NO:"
                        label-for="party-nsic-no"
                    >
                        <b-form-input
                            id="party-nsic-no"
                            placeholder="NSIC NO"
                            v-model="formData.nsicNo"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="LWF NO:"
                        label-for="party-lwf-no"
                    >
                        <b-form-input
                            id="party-lwf-no"
                            placeholder="LWF NO"
                            v-model="formData.lwfNo"
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
                Save
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
                    if (typeof (res.data.data.taxDetails) === "object"){
                        this.formData = res.data.data.taxDetails
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
                isTaxDetails: true,
                gstin: null,
                cinNo: null,
                tanNo: null,
                udyamNo: null,
                panNo: null,
                uid: null,
                arn: null,
                tinVatNo: null,
                tinCstNo: null,
                eccNo: null,
                range: null,
                division: null,
                serviceTaxNo: null,
                nsicNo: null,
                lwfNo: null,
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
                this.$store.dispatch('master-add/editPartyMaster', this.formData).then(() => {
                    this.$toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Tax Details Added',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: `You have successfully Tax Details`,
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
