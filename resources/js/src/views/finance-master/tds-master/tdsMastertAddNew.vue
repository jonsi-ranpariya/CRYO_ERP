<template>
    <b-sidebar
        id="add-new-user-sidebar"
        :visible="isAddNewUserSidebarActive"
        bg-variant="white"
        sidebar-class="sidebar-lg"
        shadow
        backdrop
        no-header
        right
        @hidden="resetForm"
        @change="(val) => $emit('update:is-add-new-user-sidebar-active', val)"
    >
        <template #default="{ hide }">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center content-sidebar-header px-2 py-1">
                <h5 class="mb-0">
                    Add/Edit TDS Master
                </h5>

                <feather-icon
                    class="ml-1 cursor-pointer"
                    icon="XIcon"
                    size="16"
                    @click="hide"
                />

            </div>

            <!-- BODY -->
            <validation-observer
                #default="{ handleSubmit }"
                ref="refFormObserver"
            >
                <!-- Form -->
                <b-form
                    class="p-2"
                    @submit.prevent="handleSubmit(saveMyERPData)"
                    @reset.prevent="resetForm"
                >

                    <!-- UOM Name -->
                    <validation-provider
                        #default="validationContext"
                        name="Type"
                        rules="required"
                    >
                        <b-form-group
                            label="Type"
                            label-for="tdsType"
                        >
                            <b-form-input
                                id="tdsType"
                                v-model="userformData.tdsType"
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <b-form-group
                        label="Section"
                        label-for="tdsSection"
                    >
                        <b-form-input
                            id="tdsSection"
                            v-model="userformData.tdsSection"
                        />
                    </b-form-group>

                    <b-form-group
                        label="Payment Code"
                        label-for="tdsPaymentCode"
                    >
                        <b-form-input
                            id="tdsPaymentCode"
                            v-model="userformData.tdsPaymentCode"
                        />
                    </b-form-group>

                    <b-form-group
                        label="Exemption Limit"
                        label-for="tdsExemptionLimit"
                    >
                        <b-form-input
                            id="tdsExemptionLimit"
                            v-model="userformData.tdsExemptionLimit"
                            type="number"
                        />
                    </b-form-group>

                    <b-form-group
                        label="TDS %"
                        label-for="tdsPercentage"
                    >
                        <b-form-input
                            id="tdsPercentage"
                            v-model="userformData.tdsPercentage"
                            type="number"
                        />
                    </b-form-group>

                    <b-form-group
                        label="Remark"
                        label-for="tdsRemark"
                    >
                        <b-form-textarea
                            id="tdsRemark"
                            v-model="userformData.tdsRemark"
                            rows="2"
                        />
                    </b-form-group>

                    <!-- Form Actions -->
                    <div class="d-flex mt-2">
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="primary"
                            class="mr-2"
                            type="submit"
                        >
                            Save Data
                        </b-button>
                        <b-button
                            v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                            type="button"
                            variant="outline-secondary"
                            @click="hideMySidebar()"
                        >
                            Cancel
                        </b-button>
                    </div>

                </b-form>
            </validation-observer>
        </template>
    </b-sidebar>
</template>

<script>
    import {BSidebar, BForm, BFormGroup, BFormInput, BFormTextarea, BFormInvalidFeedback, BButton} from 'bootstrap-vue'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {ref} from '@vue/composition-api'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {required} from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import store from '@/store'

    export default {
        components: {
            BSidebar,
            BForm,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BFormInvalidFeedback,
            BButton,
            vSelect,

            // Form Validation
            ValidationProvider,
            ValidationObserver,
        },
        directives: {
            Ripple,
        },
        model: {
            prop: 'isAddNewUserSidebarActive',
            event: 'update:is-add-new-user-sidebar-active',
        },
        props: {
            isAddNewUserSidebarActive: {
                type: Boolean,
                required: true,
            },
            userformData: {
                type: Object,
                required: true,
            },
        },
        data() {
            return {
                required,
            }
        },
        setup(props) {

            const blankUserData = props.userformData

            const userData = ref(JSON.parse(JSON.stringify(blankUserData)))

            const resetuserData = () => {
                userData.value = JSON.parse(JSON.stringify(blankUserData))
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetuserData)

            return {
                userData,
                refFormObserver,
                getValidationState,
                resetForm,
            }
        },
        methods: {

            saveMyERPData() {


                const hasIdExist = this.containsKey(this.userformData, '_id')

                if (hasIdExist) {

                    this.userformData.id = this.userformData._id

                    delete this.userformData._id

                    store.dispatch('tds-module/updateTdsMaster', this.userformData).then(response => {

                        if (response.status = 200) {

                            this.$emit('refetch-data')
                            this.$emit('update:is-add-new-user-sidebar-active', false)

                            this.$toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'TDS Master Edited',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Edited TDS Master : ${this.userformData.tdsType}.`,
                                },
                            })
                        }

                    })

                } else {

                    store.dispatch('tds-module/addTdsMaster', this.userformData).then(response => {

                        if (response.status = 200) {

                            this.$emit('refetch-data')
                            this.$emit('update:is-add-new-user-sidebar-active', false)

                            this.$toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'TDS Master Created',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Created New TDS Master : ${this.userformData.tdsType}.`,
                                },
                            })
                        }

                    })

                }

            },
            containsKey(obj, key) {
                return Object.keys(obj).includes(key)
            },
            hideMySidebar() {
                this.$emit('refetch-data')
                this.$emit('update:is-add-new-user-sidebar-active', false)
            },
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';

    #add-new-user-sidebar {
        .vs__dropdown-menu {
            max-height: 200px !important;
        }
    }
</style>
