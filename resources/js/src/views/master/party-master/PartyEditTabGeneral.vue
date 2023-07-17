<template>
    <div>

        <!-- User Info: Input Fields -->
        <b-form @submit.prevent="submitFormData">
            <b-row>
                <b-col md="12">
                    <hr>
                    <h6>General Details</h6>
                    <hr>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="Working Hours"
                        label-for="workingHours"
                    >
                        <b-form-input
                            id="workingHours"
                            placeholder="Working Hours"
                            v-model="formData.workingHours"
                        />
                    </b-form-group>
                </b-col>

                <b-col md="6">
                    <b-form-group
                        label="Vendor Code"
                        label-for="general-vendor-code"
                    >
                        <b-form-input
                            id="general-vendor-code"
                            placeholder="Vendor Code"
                            v-model="formData.vendorCode"
                        />
                    </b-form-group>
                </b-col>

                <b-col md="6">
                    <b-form-group
                        label="Holiday"
                        label-for="general-holiday"
                    >
                        <b-form-input
                            id="general-holiday"
                            placeholder="Holiday"
                            v-model="formData.holiday"
                        />
                    </b-form-group>
                </b-col>

                <b-col md="6">
                    <b-form-group
                        label="Our Concern Person"
                        label-for="general-concern-person"
                    >
                        <b-form-input
                            id="concern-person"
                            placeholder="Our Concern Person"
                            v-model="formData.ourConcernPerson"
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
    import {ref,onUnmounted} from '@vue/composition-api'
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

            ValidationProvider,
            ValidationObserver,
        },
        directives: {
            Ripple,
        },
        created(){
            this.$store.dispatch('master-add/fetchPartyDetail',{id: router.currentRoute.params.id}).then(res => {
                if (typeof (res.data.data.generalData) === "object"){
                    this.formData = res.data.data.generalData
                }
            })
        },
        setup() {
            const APP_STORE_MODULE_NAME = 'master-add'
            if (!store.hasModule(APP_STORE_MODULE_NAME)) store.registerModule(APP_STORE_MODULE_NAME, partyStoreModule)
            onUnmounted(() => {
                if (store.hasModule(APP_STORE_MODULE_NAME)) store.unregisterModule(APP_STORE_MODULE_NAME)
            })

            const generalFormData = {
                id: router.currentRoute.params.id,
                isGeneralData: true,
                workingHours: null,
                vendorCode: null,
                holiday: null,
                ourConcernPerson: null,
                allowMultiple: 0,
            }

            const formData = ref(JSON.parse(JSON.stringify(generalFormData)))

            const resetGroupData = () => {
                formData.value = JSON.parse(JSON.stringify(generalFormData))
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
                            title: 'General Update',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: `You have successfully Updated General`,
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
