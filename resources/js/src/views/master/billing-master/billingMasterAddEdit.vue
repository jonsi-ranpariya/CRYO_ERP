<template>
    <b-sidebar
        id="add-new-user-sidebar"
        :visible="isAddNewUserSidebarActive"
        bg-variant="white"
        sidebar-class="sidebar-lg"
        shadow
        no-backdrop
        no-header
        right
        @hidden="resetForm"
        @change="(val) => $emit('update:is-add-new-user-sidebar-active', val)"
    >
        <template #default="{ hide }">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center content-sidebar-header px-2 py-1">
                <h5 class="mb-0">
                    Add/Edit Billing Master
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
                    <validation-provider
                        #default="validationContext"
                        name="Cal Code"
                        rules="required"
                    >
                        <b-form-group>

                            <label for="calCode">Cal Code <span
                                class="text-danger erp_required_star">*</span></label>

                            <b-form-input
                                id="calCode"
                                v-model="userformData.calCode"
                                :state="getValidationState(validationContext)"
                                trim
                                maxlength="3"
                                class="text-uppercase"
                            />
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>
                    <validation-provider
                        #default="validationContext"
                        name="Name"
                        rules="required"
                    >
                        <b-form-group>

                            <label for="name">Name <span
                                class="text-danger erp_required_star">*</span></label>

                            <b-form-input
                                id="name"
                                v-model="userformData.name"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>
                    <validation-provider
                        #default="validationContext"
                        name="Type"
                        rules="required"
                    >
                        <b-form-group :state="getValidationState(validationContext)">
                            <label for="valueType">Type <span
                                class="text-danger erp_required_star">*</span></label>
                            <v-select
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="typeOptions"
                                :clearable="false"
                                input-id="valueType"
                                v-model="userformData.valueType"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>
                    <validation-provider
                        #default="validationContext"
                        name="Default Value"
                        rules="required"
                    >
                        <b-form-group>

                            <label for="defaultValue">Default Value <span
                                class="text-danger erp_required_star">*</span></label>

                            <b-form-input
                                id="defaultValue"
                                v-model="userformData.defaultValue"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>
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
    import {BSidebar, BForm, BFormGroup, BFormInput, BFormInvalidFeedback, BButton} from 'bootstrap-vue'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {ref} from '@vue/composition-api'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {required} from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import store from '@/store'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'

    export default {
        components: {
            BSidebar,
            BForm,
            BFormGroup,
            BFormInput,
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
                typeOptions: [
                    {
                        label: 'By Percent',
                        value: 0
                    },
                    {
                        label: 'By Value',
                        value: 1
                    },
                ],
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
                    store.dispatch('billing-master/updateBillingMaster', this.userformData).then(response => {
                        if (response.status === 200) {
                            this.$emit('refetch-data')
                            this.$emit('update:is-add-new-user-sidebar-active', false)
                            this.$toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Billing Master Edited',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Edited Billing Master : ${this.userformData.name}.`,
                                },
                            })
                        }
                    })
                } else {
                    store.dispatch('billing-master/addBillingMaster', this.userformData).then(response => {
                        if (response.status === 200) {
                            this.$emit('refetch-data')
                            this.$emit('update:is-add-new-user-sidebar-active', false)
                            this.$toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Billing Master Created',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Created New Billing Master : ${this.userformData.name}.`,
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
