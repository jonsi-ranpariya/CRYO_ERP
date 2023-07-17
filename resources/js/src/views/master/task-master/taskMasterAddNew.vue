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
                    Add/Edit Task Master
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
                        name="Task"
                        rules="required"
                    >
                        <b-form-group>

                            <label for="taskName">Task <span
                                class="text-danger erp_required_star">*</span></label>

                            <b-form-input
                                id="taskName"
                                v-model="userformData.taskName"
                                v-uppercaseInput
                                :state="getValidationState(validationContext)"
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <b-form-group
                        label="Auto Activity Alert"
                        label-for="autoActivityAlert"
                    >
                        <v-select
                            v-model="userformData.autoActivityAlert"
                            taggable
                            push-tags
                            placeholder="Select is Alert"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="autoActivityAlertOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="autoActivityAlert"
                        />
                    </b-form-group>

                    <b-form-group
                        label="Auto SMS Alert"
                        label-for="autoSmsAlert"
                    >
                        <v-select
                            v-model="userformData.autoSmsAlert"
                            taggable
                            push-tags
                            placeholder="Select is Alert"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="autoSmsAlertOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="autoSmsAlert"
                        />
                    </b-form-group>

                    <b-form-group
                        label="Auto Mail Alert"
                        label-for="autoMailAlert"
                    >
                        <v-select
                            v-model="userformData.autoMailAlert"
                            taggable
                            push-tags
                            placeholder="Select is Alert"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="autoMailAlertOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="autoMailAlert"
                        />
                    </b-form-group>

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
                        label="Subject"
                        label-for="taskSubject"
                    >
                        <b-form-input
                            id="taskSubject"
                            v-model="userformData.taskSubject"
                        />
                    </b-form-group>

                    <b-form-group
                        label="Msg Body"
                        label-for="taskMsgBody"
                    >
                        <b-form-textarea
                            id="taskMsgBody"
                            v-model="userformData.taskMsgBody"
                            rows="2"
                        />
                    </b-form-group>

                    <b-form-group
                        label="Task Intimation User"
                        label-for="taskIntimationUser"
                    >
                        <v-select
                            v-model="userformData.taskIntimationUser"
                            multiple
                            taggable
                            push-tags
                            placeholder="Select user Right"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="userOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="taskIntimationUser"
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
    import {uppercaseInput} from "@core/utils/utils";

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
            userOptions: {
                type: Array,
                required: true,
            },
            autoActivityAlertOptions: {
                type: Array,
                required: true,
            },
            autoSmsAlertOptions: {
                type: Array,
                required: true,
            },
            autoMailAlertOptions: {
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

                    store.dispatch('task-master-module/updateTaskMaster', this.userformData).then(response => {

                        if (response.status = 200) {

                            this.$emit('refetch-data')
                            this.$emit('update:is-add-new-user-sidebar-active', false)

                            this.$toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Task Detail Edited',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Edited Task : ${this.userformData.taskName}.`,
                                },
                            })
                        }

                    })

                } else {

                    store.dispatch('task-master-module/addTaskMaster', this.userformData).then(response => {

                        if (response.status = 200) {

                            this.$emit('refetch-data')
                            this.$emit('update:is-add-new-user-sidebar-active', false)

                            this.$toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Task Detail Created',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Created New Task : ${this.userformData.taskName}.`,
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
