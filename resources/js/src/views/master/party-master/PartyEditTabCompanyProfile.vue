<template>
    <div>
        <b-form @submit.prevent="submitFormData">
            <b-row>
                <b-col md="12">
                    <hr>
                    <h6>Company Profile Details</h6>
                    <hr>
                </b-col>

                <b-col md="12">
                    <b-form-group
                        label="Company Profile"
                        label-for="company-profile"
                    >
                        <b-form-textarea
                            id="company-profile"
                            placeholder="Company Profile"
                            rows="5"
                            v-model="formData.profile"
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
                    if (typeof (res.data.data.companyProfile) === "object"){
                        this.formData = res.data.data.companyProfile
                    }
                })
        },
        setup(props) {
            const APP_STORE_MODULE_NAME = 'master-add'
            if (!store.hasModule(APP_STORE_MODULE_NAME)) store.registerModule(APP_STORE_MODULE_NAME, partyStoreModule)
            onUnmounted(() => {
                if (store.hasModule(APP_STORE_MODULE_NAME)) store.unregisterModule(APP_STORE_MODULE_NAME)
            })

            const partyFormData = {
                id: router.currentRoute.params.id,
                iscompanyProfile: true,
                profile: null,
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
                            title: 'Company Profile Added',
                            icon: 'CheckSquareIcon',
                            variant: 'success',
                            text: `You have successfully Company Profile`,
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
