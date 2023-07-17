<template>
    <b-sidebar
        id="edit-new-party-group-master-sidebar"
        :visible="isEditNewPartyGroupMasterSidebarActive"
        bg-variant="white"
        sidebar-class="sidebar-lg"
        shadow
        backdrop
        no-header
        right
        @change="(val) => $emit('update:is-edit-new-party-group-master-sidebar-active', val)"
    >
        <template #default="{ hide }">
            <div class="d-flex justify-content-between align-items-center content-sidebar-header px-2 py-1">
                <h5 class="mb-0">
                    Edit New Party
                </h5>

                <feather-icon
                    class="ml-1 cursor-pointer"
                    icon="XIcon"
                    size="16"
                    @click="hide"
                />

            </div>
            <!--Body-->
            <validation-observer
                #default="{ handleSubmit }"
                ref="refFormObserver"
            >
                <!-- Form -->
                <b-form
                    class="p-2"
                    @submit.prevent="handleSubmit(onUpdate)"
                    @reset.prevent="resetForm"
                >
                    <!-- Group Name -->
                    <validation-provider
                        #default="validationContext"
                        name="Group Name"
                        rules="required"
                    >
                        <b-form-group
                            label="Group Name"
                            label-for="group-name"
                        >

                            <b-form-input
                                id="group-name"
                                v-model="partyGroupData.groupName"
                                placeholder="Party Group"
                                autofocus
                                v-uppercaseInput
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
                            Update
                        </b-button>
                        <b-button
                            v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                            type="button"
                            variant="outline-secondary"
                            @click="hide"
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
    import { ref } from '@vue/composition-api'
    import { required } from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import store from '@/store'
    import Ripple from 'vue-ripple-directive'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import { useToast } from 'vue-toastification/composition'
    import dispatch from "../../../router/routes/dispatch";
    import {uppercaseInput} from "@core/utils/utils";

    export default {
        components: {
            BSidebar,
            BForm,
            BFormGroup,
            BFormInput,
            BFormInvalidFeedback,
            BButton,

            // Form Validation
            ValidationProvider,
            ValidationObserver,
        },
        directives: {
            Ripple,
            uppercaseInput,
        },
        model : {
            prop: ['isEditNewPartyGroupMasterSidebarActive','partyGroupData'],
            event: 'update:is-edit-new-party-group-master-sidebar-active',
        },
        props: {
            isEditNewPartyGroupMasterSidebarActive: {
                type: Boolean,
                required: true,
            },
            partyGroupData:{
                type: Object,
                required: true
            }
        },
        data() {
            return {
                required,
            }
        },
        setup(props, { emit }) {
            const toast = useToast()

            const blankGroupData = {
                groupName: '',
            }

            const groupData = ref(JSON.parse(JSON.stringify(blankGroupData)))

            const resetgroupData = () => {
                groupData.value = JSON.parse(JSON.stringify(blankGroupData))
            }

            const onSubmit = () => {

            }

            const { refFormObserver, getValidationState, resetForm } = formValidation(resetgroupData)

            return {
                groupData,
                //onSubmit,

                refFormObserver,
                getValidationState,
                resetForm,
            }
        },
        methods: {
            onUpdate(){
                store.dispatch('master-add/updatePartyGroupMaster', this.partyGroupData).then(response => {
                    if (response.status == 200){
                        store.dispatch('master-add/fetchPartyGroupMasterList')
                        this.$emit('update:is-edit-new-party-group-master-sidebar-active', false)
                        this.$toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: `Group Update`,
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `Group name : ${this.partyGroupData.groupName} Update Successfully`,
                            },
                        })
                    }else{
                        this.toast({
                            component: ToastificationContent,
                            props: {
                                title: 'error',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: `Something went wrong`
                            },
                        })
                    }
                })
            }
        }
    }
</script>

