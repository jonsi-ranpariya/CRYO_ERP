<template>
    <b-form @submit.prevent="submitFormData">
        <b-row>
            <b-col md="12">
                <hr>
                <h4>Item Details</h4>
            </b-col>
        <b-col md="12">
            <hr>
        </b-col>
        <b-col md="6">
            <hr>
            <h4>Document Header</h4>
            <hr>
            <b-form-group
                label="Header Options"
                label-for="acknowledgeOption"
            >
                <v-select
                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                    :options="acknowledgeOptions"
                    :clearable="false"
                    input-id="acknowledgeOption"
                    v-model="formData.acknowledgeOption"
                    v-on:input="getAcknowledgeText(formData.acknowledgeOption)"
                />
            </b-form-group>
            <b-form-group
                label="Text"
                label-for="acknowledgeText"
            >
                <b-form-textarea
                    rows="5"
                    id="acknowledgeText"
                    v-model="formData.acknowledgeText"
                />
            </b-form-group>
        </b-col>
        <b-col md="6">
            <hr>
            <h4>Document Footer</h4>
            <hr>
            <b-form-group
                label="Footer Options"
                label-for="regretOption"
            >
                <v-select
                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                    :options="regretOptions"
                    :clearable="false"
                    input-id="regretOption"
                    v-model="formData.regretOption"
                    v-on:input="getRegretText(formData.regretOption)"
                />
            </b-form-group>
            <b-form-group
                label="Text"
                label-for="regretText"
            >
                <b-form-textarea
                    rows="5"
                    id="regretText"
                    v-model="formData.regretText"
                />
            </b-form-group>
        </b-col>
        <b-col md="12">
            <hr>
            <b-button
                class="float-right"
                variant="primary"
                type="submit"
            >
                Save
            </b-button>
        </b-col>
    </b-row>
    </b-form>
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
        BFormInvalidFeedback,
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
    import {required, numeric, email} from '@validations'
    import {ref, onUnmounted} from '@vue/composition-api'
    import {ValidationProvider, ValidationObserver, validate} from 'vee-validate'
    import salesStoreModule from "../../salesStoreModule";

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
            BFormInvalidFeedback,
            BDropdown,
            BDropdownItem,
            vSelect,

            ValidationProvider,
            ValidationObserver
        },
        data(){
            return {
                acknowledgeOptions: [],
                regretOptions: [],
            }
        },
        created(){
            this.$http.get('/api/new/document-sales-enquiry-header-options').then(res => {
                this.acknowledgeOptions = res.data.data
            })

            this.$http.get('/api/new/document-sales-enquiry-footer-options').then(res => {
                this.regretOptions = res.data.data
            })

            this.$http.get(`/api/sales-enquiry/${router.currentRoute.params.id}`).then(res => {
                if (typeof (res.data.data.letterData) === 'object'){
                    this.formData = res.data.data.letterData
                }
            })
        },
        setup() {
            const toast = useToast()
            const APP_STORE_MODULE_NAME = 'sales-module'
            if (!store.hasModule(APP_STORE_MODULE_NAME)) store.registerModule(APP_STORE_MODULE_NAME, salesStoreModule)
            onUnmounted(() => {
                if (store.hasModule(APP_STORE_MODULE_NAME)) store.unregisterModule(APP_STORE_MODULE_NAME)
            })
            const partyDetailFormData = {
                id: router.currentRoute.params.id,
                isLetterTab: true,
                acknowledgeOption: null,
                acknowledgeText: null,
                regretOption: null,
                regretText: null,
            }
            const formData = ref(JSON.parse(JSON.stringify(partyDetailFormData)))
            const resetGroupData = () => {
                formData.value = JSON.parse(JSON.stringify(partyDetailFormData))
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
            getAcknowledgeText(val){
                this.formData.acknowledgeText = val.document
            },
            getRegretText(val){
                this.formData.regretText = val.document
            },
            submitFormData(){
                store.dispatch('sales-module/updateSalesEnquiry', this.formData).then(response => {
                    this.$toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: 'Ackn/Regret Letter Added',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: `You have successfully Added Ackn/Regret Letter.`,
                        },
                    })
                })
            },
        }
    }
</script>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
