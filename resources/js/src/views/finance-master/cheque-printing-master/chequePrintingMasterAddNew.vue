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
                    Add/Edit Cheque Printing
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
                        name="Format Name"
                        rules="required"
                    >
                        <b-form-group
                            label="Format Name"
                            label-for="formatName"
                        >
                            <b-form-input
                                id="formatName"
                                v-model="userformData.formatName"
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <h5>LEFT MARGIN</h5>

                    <validation-provider
                        #default="validationContext"
                        name="Date"
                        rules="required"
                    >
                        <b-form-group
                            label="Date"
                            label-for="leftMarginDate"
                        >
                            <b-form-input
                                id="leftMarginDate"
                                v-model="userformData.leftMarginDate"
                                type="number"
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <validation-provider
                        #default="validationContext"
                        name="Payee"
                        rules="required"
                    >
                        <b-form-group
                            label="Payee"
                            label-for="leftMarginPayee"
                        >
                            <b-form-input
                                id="leftMarginPayee"
                                v-model="userformData.leftMarginPayee"
                                type="number"
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <validation-provider
                        #default="validationContext"
                        name="A/c Payee"
                        rules="required"
                    >
                        <b-form-group
                            label="A/c Payee"
                            label-for="leftMarginAcPayee"
                        >
                            <b-form-input
                                id="leftMarginAcPayee"
                                v-model="userformData.leftMarginAcPayee"
                                type="number"
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <validation-provider
                        #default="validationContext"
                        name="Amount"
                        rules="required"
                    >
                        <b-form-group
                            label="Amount"
                            label-for="leftMarginAmount"
                        >
                            <b-form-input
                                id="leftMarginAmount"
                                v-model="userformData.leftMarginAmount"
                                type="number"
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <validation-provider
                        #default="validationContext"
                        name="Amount In Words"
                        rules="required"
                    >
                        <b-form-group
                            label="Amount In Words"
                            label-for="leftMarginAmountInWord"
                        >
                            <b-form-input
                                id="leftMarginAmountInWord"
                                v-model="userformData.leftMarginAmountInWord"
                                type="number"
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <h5>TOP MARGIN</h5>

                    <validation-provider
                        #default="validationContext"
                        name="Date"
                        rules="required"
                    >
                        <b-form-group
                            label="Date"
                            label-for="topMarginDate"
                        >
                            <b-form-input
                                id="topMarginDate"
                                v-model="userformData.topMarginDate"
                                type="number"
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <validation-provider
                        #default="validationContext"
                        name="Payee"
                        rules="required"
                    >
                        <b-form-group
                            label="Payee"
                            label-for="topMarginPayee"
                        >
                            <b-form-input
                                id="topMarginPayee"
                                v-model="userformData.topMarginPayee"
                                type="number"
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <validation-provider
                        #default="validationContext"
                        name="A/c Payee"
                        rules="required"
                    >
                        <b-form-group
                            label="A/c Payee"
                            label-for="topMarginAcPayee"
                        >
                            <b-form-input
                                id="topMarginAcPayee"
                                v-model="userformData.topMarginAcPayee"
                                type="number"
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <validation-provider
                        #default="validationContext"
                        name="Amount"
                        rules="required"
                    >
                        <b-form-group
                            label="Amount"
                            label-for="topMarginAmount"
                        >
                            <b-form-input
                                id="topMarginAmount"
                                v-model="userformData.topMarginAmount"
                                type="number"
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <validation-provider
                        #default="validationContext"
                        name="Amount In Words"
                        rules="required"
                    >
                        <b-form-group
                            label="Amount In Words"
                            label-for="topMarginAmountInWord"
                        >
                            <b-form-input
                                id="topMarginAmountInWord"
                                v-model="userformData.topMarginAmountInWord"
                                type="number"
                                :state="getValidationState(validationContext)"
                                trim
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
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import store from '@/store'

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

                    store.dispatch('cheque-module/updateChequePrintingFormatMaster', this.userformData).then(response => {

                        if (response.status = 200) {

                            this.$emit('refetch-data')
                            this.$emit('update:is-add-new-user-sidebar-active', false)

                            this.$toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Format Edited',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Edited Format : ${this.userformData.formatName}.`,
                                },
                            })
                        }

                    })

                } else {

                    store.dispatch('cheque-module/addChequePrintingFormatMaster', this.userformData).then(response => {

                        if (response.status = 200) {

                            this.$emit('refetch-data')
                            this.$emit('update:is-add-new-user-sidebar-active', false)

                            this.$toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Format Created',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Created New Format : ${this.userformData.formatName}.`,
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
