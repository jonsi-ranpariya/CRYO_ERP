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
                    Add/Edit Document Footer
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

                    <!-- Reason -->
                    <validation-provider
                        #default="validationContext"
                        name="Footer Name"
                        rules="required"
                    >
                        <b-form-group>

                            <label for="footerName">Footer Name<span
                                class="text-danger erp_required_star">*</span></label>

                            <b-form-input
                                id="footerName"
                                v-model="userformData.footerName"
                                :state="getValidationState(validationContext)"
                                v-uppercase-input
                            />

                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!-- Document Header -->

                    <validation-provider
                        #default="validationContext"
                        name="Footer"
                        rules="required"
                    >
                        <b-form-group>
                            <label for="footer">Footer<span
                                class="text-danger erp_required_star">*</span></label>

                            <b-form-textarea
                                id="footer"
                                v-model="userformData.footer"
                                :state="getValidationState(validationContext)"
                                rows="5"
                            />
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!-- Reason Type -->

                    <validation-provider
                        #default="validationContext"
                        name="Footer Type"
                        rules="required"
                    >
                        <b-form-group
                            :state="getValidationState(validationContext)"
                        >
                            <label for="footerType">Footer Type<span
                                class="text-danger erp_required_star">*</span></label>

                            <v-select
                                v-model="userformData.footerType"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="documentFooterTypeOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                id="footerType"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>
                    <b-form-group>
                        <b-form-checkbox
                            id="isDefault"
                            name="checkbox-input"
                            class="mt-1 ml-1"
                            value="Yes"
                            v-model="userformData.isDefault"
                        >
                            Is Default
                        </b-form-checkbox>
                    </b-form-group>

                    <!-- Form Actions -->
                    <div class="d-flex mt-2">
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="primary"
                            class="mr-2"
                            type="submit"
                        >
                            Save
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
    import {
        BSidebar,
        BForm,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
        BButton,
        BFormTextarea,
        BFormCheckbox,
    } from 'bootstrap-vue'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {ref} from '@vue/composition-api'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {required} from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import store from '@/store'
    import {uppercaseInput} from "../../../@core/utils/utils";
    import Swal from "sweetalert2";
    import axios from '@axios'

    export default {
        components: {
            BSidebar,
            BForm,
            BFormGroup,
            BFormInput,
            BFormInvalidFeedback,
            BButton,
            BFormTextarea,
            vSelect,
            BFormCheckbox,
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
            documentFooterTypeOption: {
                type: Array,
                required: true,
            }
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
                    axios.post('/api/new/document-footer-master-exist',
                        {
                            id: this.userformData._id,
                            footerName: this.userformData.footerName
                        }
                    ).then(res => {
                            if (res.data.data === true) {

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Footer Name ' + this.userformData.footerName + ' Already Exist!',
                                })

                            } else {
                    this.userformData.id = this.userformData._id
                    delete this.userformData._id

                            store.dispatch('document-footer-module/updateDocumentFooter', this.userformData).then(response => {
                                if (response.status = 200) {
                                    this.$emit('refetch-data')
                                    this.$emit('update:is-add-new-user-sidebar-active', false)
                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Document Footer Edited',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Edited Document Footer : ${this.userformData.footerName}.`,
                                        },
                                    })
                                }
                            })
                        }
                    })
                } else {
                    axios.post('/api/new/document-footer-master-exist',
                        {
                            footerName: this.userformData.footerName
                        }
                    ).then(res => {
                        if (res.data.data === true) {

                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Footer Name ' + this.userformData.footerName + ' Already Exist!',
                            })

                        } else {
                            store.dispatch('document-footer-module/addDocumentFooter', this.userformData).then(response => {
                                if (response.status = 200) {
                                    this.$emit('refetch-data')
                                    this.$emit('update:is-add-new-user-sidebar-active', false)
                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Document Footer Created',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Created New Document Footer : ${this.userformData.footerName}.`,
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
