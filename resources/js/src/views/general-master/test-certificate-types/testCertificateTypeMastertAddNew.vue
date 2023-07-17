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
                    Add/Edit Certificate
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
                        name="Code"
                        rules="required|max:4"
                    >
                        <b-form-group>

                            <label for="code">Code <span
                                class="text-danger erp_required_star">*</span></label>

                            <b-form-input
                                id="code"
                                v-model="userformData.code"
                                v-uppercaseInput
                                :state="getValidationState(validationContext)"
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <validation-provider
                        #default="validationContext"
                        name="TC Type"
                        rules="required"
                    >
                        <b-form-group>

                            <label for="tcType">TC Type <span
                                class="text-danger erp_required_star">*</span></label>

                            <b-form-textarea
                                id="tcType"
                                v-model="userformData.tcType"
                                :state="getValidationState(validationContext)"
                                rows="2"
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
    import {BSidebar, BForm, BFormGroup, BFormInput, BFormTextarea, BFormInvalidFeedback, BButton} from 'bootstrap-vue'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {ref} from '@vue/composition-api'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {required} from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import store from '@/store'
    import axios from '@axios'
    import Swal from 'sweetalert2'
    import {uppercaseInput} from "@core/utils/utils";

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
            uppercaseInput,
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

                    axios.post('/api/certificate-type-master-exist',
                        {
                            id: this.userformData._id,
                            code: this.userformData.code
                        }
                    ).then(res => {
                        if (res.data.data === true) {

                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Certificate Types ' + this.userformData.code + ' Already Exist!',
                            })

                        } else {

                            // save Data

                            this.userformData.id = this.userformData._id

                            delete this.userformData._id

                            store.dispatch('test-certy-module/editTestCertificateData', this.userformData).then(response => {

                                if (response.status = 200) {

                                    this.$emit('refetch-data')
                                    this.$emit('update:is-add-new-user-sidebar-active', false)

                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Test Certificate Edited',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Edited Certificate : ${this.userformData.code}.`,
                                        },
                                    })
                                }

                            })
                        }
                    })


                } else {

                    axios.post('/api/certificate-type-master-exist',
                        {
                            code: this.userformData.code
                        }
                    ).then(res => {
                        if (res.data.data === true) {

                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Certificate Types ' + this.userformData.code + ' Already Exist!',
                            })

                        } else {

                            // save Data

                            store.dispatch('test-certy-module/addTestCertificateData', this.userformData).then(response => {

                                if (response.status = 200) {

                                    this.$emit('refetch-data')
                                    this.$emit('update:is-add-new-user-sidebar-active', false)

                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Test Certificate Created',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Created New Certificate : ${this.userformData.code}.`,
                                        },
                                    })
                                }

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
