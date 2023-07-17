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
                    Add/Edit Progress Stage Master
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
                        name="Stage For"
                        rules="required"
                    >
                        <b-form-group
                            :state="getValidationState(validationContext)"
                        >
                            <label for="stageFor">Stage For <span
                                class="text-danger erp_required_star">*</span></label>

                            <v-select
                                v-model="userformData.stageFor"
                                taggable
                                push-tags
                                placeholder="Select Stage For"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="stageForOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                id="stageFor"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <validation-provider
                        #default="validationContext"
                        name="Stage"
                        rules="required"
                    >
                        <b-form-group
                            :state="getValidationState(validationContext)"
                        >
                            <label for="stageStatus">Stage <span
                                class="text-danger erp_required_star">*</span></label>

                            <v-select
                                v-model="userformData.stageStatus"
                                taggable
                                push-tags
                                placeholder="Select Stage"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="stageOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                id="stageStatus"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <b-form-group
                        label="Required Days"
                        label-for="requiredDays"
                    >
                        <b-form-input
                            id="requiredDays"
                            type="number"
                            v-model="userformData.requiredDays"
                        />
                    </b-form-group>

                    <b-form-group
                        label="Responsible User"
                        label-for="responsibleUser"
                    >
                        <v-select
                            v-model="userformData.responsibleUser"
                            taggable
                            push-tags
                            placeholder="Select Responsible User"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="userOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="responsibleUser"
                        />
                    </b-form-group>

                    <b-form-group
                        label="Remark"
                        label-for="stageRemark"
                    >
                        <b-form-textarea
                            id="stageRemark"
                            v-model="userformData.stageRemark"
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
    import {BSidebar, BForm, BFormGroup, BFormInput, BFormInvalidFeedback, BButton, BFormTextarea} from 'bootstrap-vue'
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
            BFormTextarea,

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
            userOptions: {
                type: Array,
                required: true,
            },
            stageForOptions: {
                type: Array,
                required: true,
            },
            stageOptions: {
                type: Array,
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

                    store.dispatch('progress-stage-module/updateProgressStageMaster', this.userformData).then(response => {

                        if (response.status = 200) {

                            this.$emit('refetch-data')
                            this.$emit('update:is-add-new-user-sidebar-active', false)

                            this.$toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Stage Detail Edited',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Edited Stage : ${this.userformData.stageStatus}.`,
                                },
                            })
                        }

                    })

                } else {

                    store.dispatch('progress-stage-module/addProgressStageMaster', this.userformData).then(response => {

                        if (response.status = 200) {

                            this.$emit('refetch-data')
                            this.$emit('update:is-add-new-user-sidebar-active', false)

                            this.$toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Stage Detail Created',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Created New Stage : ${this.userformData.stageStatus}.`,
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
